package com.example.isys2101group15.utils;


import com.example.isys2101group15.entity.FoodItem;
import com.example.isys2101group15.entity.Privilege;
import com.example.isys2101group15.entity.Restaurant;
import com.example.isys2101group15.entity.RestaurantTable;
import com.example.isys2101group15.entity.Role;
import com.example.isys2101group15.entity.UserE;
import com.example.isys2101group15.repository.FoodItemRepository;
import com.example.isys2101group15.repository.PrivilegesRepository;
import com.example.isys2101group15.repository.RestaurantRepository;
import com.example.isys2101group15.repository.RestaurantTableRepository;
import com.example.isys2101group15.repository.RolesRepository;
import com.example.isys2101group15.repository.UserEntityRepository;
import com.opencsv.CSVReader;
import com.opencsv.exceptions.CsvValidationException;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.util.Arrays;
import java.util.Collection;
import java.util.List;
import javax.swing.text.TabableView;
import javax.transaction.Transactional;
import lombok.RequiredArgsConstructor;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationListener;
import org.springframework.context.event.ContextRefreshedEvent;
import org.springframework.data.geo.Point;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.factory.PasswordEncoderFactories;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;
import org.springframework.util.ResourceUtils;

@Component
@RequiredArgsConstructor
public class SetupDataLoader implements ApplicationListener<ContextRefreshedEvent> {


  private final PasswordEncoder passwordEncoder;
  private static final Logger logger = LoggerFactory.getLogger(SetupDataLoader.class.getName());
  boolean alreadySetup = false;

  private final UserEntityRepository userRepository;
  private final PrivilegesRepository privilegeRepository;
  private final RolesRepository roleRepository;
  private final FoodItemRepository foodItemRepository;
  private final RestaurantTableRepository restaurantTableRepository;
  private final RestaurantRepository restaurantRepository;


  @Override
  @Transactional
  public void onApplicationEvent(ContextRefreshedEvent event) {
    if (alreadySetup)
      return;
    Privilege readPrivilege
        = createPrivilegeIfNotFound("READ_PRIVILEGE");
    Privilege writePrivilege
        = createPrivilegeIfNotFound("WRITE_PRIVILEGE");

    List<Privilege> adminPrivileges = Arrays.asList(
        readPrivilege, writePrivilege);
    createRoleIfNotFound("ROLE_ADMIN", adminPrivileges);
    createRoleIfNotFound("ROLE_USER", Arrays.asList(readPrivilege));
    Restaurant r1 = new Restaurant();
    r1.setName("Test Restaurant");
    r1.setAddress("1 Test Avenue");
    r1.setDistrict("District 1");
    r1.setProvince("Central");
    r1.setCity("Ho Chi Minh");
    r1.setCoordinate( new Point(10.773222632368222,106.69610606775547));
    restaurantRepository.save(r1);
    for (int i = 0; i < 12; i++) {
      RestaurantTable t = new RestaurantTable();
      t.setFloor(1);
      t.setTableName("Table "+ (i+1));
      t.setRestaurant(r1);
      restaurantTableRepository.save(t);
    }
    Role adminRole = roleRepository.findByName("ROLE_ADMIN");
    UserE user = new UserE();
    user.setFirstName("Test");
    user.setLastName("Test");
    user.setPassword(passwordEncoder.encode("test"));
    user.setUserName("test@test.com");
    user.setRoles(Arrays.asList(adminRole));
    user.setEnabled(true);
    userRepository.save(user);
    try{
      File file = ResourceUtils.getFile("classpath:menu.csv");
      try (FileReader reader = new FileReader(file))
      {
        CSVReader csvReader = new CSVReader(reader);
        String[] nextRecord=csvReader.readNext();
        while ((nextRecord = csvReader.readNext()) != null){
//          logger.info(Arrays.toString(nextRecord));
          FoodItem f = new FoodItem();
          f.setCategory(nextRecord[2]);
          f.setName(nextRecord[0]);
          f.setImgPath(nextRecord[1]);
          f.setDescription(nextRecord[3]);
          f.setPrice(nextRecord[4]);
          f.setNew(Boolean.parseBoolean(nextRecord[5]));
          f.setRecommended(Boolean.parseBoolean(nextRecord[6]));
          f.setOpenSpot(Boolean.parseBoolean(nextRecord[7]));
          f.setRestaurant(r1);
          foodItemRepository.save(f);
        }
      }catch (FileNotFoundException e){
        logger.error(e.getMessage());
      } catch (CsvValidationException e) {
        throw new RuntimeException(e);
      }
    }catch (IOException e){
      logger.error(e.getMessage());
    }
    alreadySetup = true;
  }

  @Transactional
  Privilege createPrivilegeIfNotFound(String name) {

    Privilege privilege = privilegeRepository.findByName(name);
    if (privilege == null) {
      privilege = new Privilege(name);
      privilegeRepository.save(privilege);
    }
    return privilege;
  }

  @Transactional
  Role createRoleIfNotFound(
      String name, Collection<Privilege> privileges) {

    Role role = roleRepository.findByName(name);
    if (role == null) {
      role = new Role(name);
      role.setPrivileges(privileges);
      roleRepository.save(role);
    }
    return role;
  }
}

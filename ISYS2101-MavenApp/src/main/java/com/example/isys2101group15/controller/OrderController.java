package com.example.isys2101group15.controller;
import com.example.isys2101group15.entity.FoodItem;
import com.example.isys2101group15.entity.OrderEntity;
import com.example.isys2101group15.model.OrderModel;
import com.example.isys2101group15.repository.FoodItemRepository;
import com.example.isys2101group15.repository.OrderRepository;
import com.example.isys2101group15.repository.UserEntityRepository;
import java.security.Principal;
import java.time.ZonedDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import lombok.RequiredArgsConstructor;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/order")
@CrossOrigin
@RequiredArgsConstructor
public class OrderController {
 private final FoodItemRepository foodRepo;
 private final OrderRepository orderRepo;
 private final UserEntityRepository userEntityRepository;
  @GetMapping("/cart")
  public String cart(){
    return "cart";
  }
  @GetMapping("/checkout")
  public String checkOut(){return "checkout";}
  @PostMapping("/cart")
  public OrderEntity makeOrder(
      @RequestBody OrderModel model,
      Principal principal
    ){
    List<FoodItem> foodItems = new ArrayList<>();
    for (Long id: model.getItemList()
    ) {
      Optional<FoodItem> food = foodRepo.findById(id);
        if (food.isEmpty()){
          return null;
        }
        foodItems.add(food.get());
    }
    OrderEntity o = new OrderEntity();
    o.setFoodItems(foodItems);
    o.setAddress(model.getAddress());
    o.setRequirement(model.getRequirement());
    o.setVoucher(model.getVoucher());
    o.setSpoon(model.getSpoon());
    o.setKetchup(model.getKetchup());
    o.setChiliSauce(model.getChiliSauce());
    o.setSilverPaper(model.getSilverPaper());
    o.setOrderCreationTime(ZonedDateTime.now());
    o.setUser(userEntityRepository.findByUserName(principal.getName()));
    return orderRepo.saveAndFlush(o);
  }
}

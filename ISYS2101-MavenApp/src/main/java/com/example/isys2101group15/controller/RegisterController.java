package com.example.isys2101group15.controller;

import com.example.isys2101group15.entity.Role;
import com.example.isys2101group15.entity.*;
import com.example.isys2101group15.model.RegistrationModel;
import com.example.isys2101group15.repository.RolesRepository;
import com.example.isys2101group15.repository.UserEntityRepository;
import java.util.Collections;
import java.util.Objects;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;


@Controller
@RequestMapping("/register")
@RequiredArgsConstructor
public class RegisterController
{
  private final UserEntityRepository userEntityRepository;
  private final RolesRepository rolesRepository;
  @GetMapping()
  public String registerPage(){
    return "registration";
  }
  @PostMapping(consumes = {MediaType.APPLICATION_FORM_URLENCODED_VALUE})
  public HttpStatus registerHandle(
      @ModelAttribute RegistrationModel registrationModel
      ){
    String r_email = registrationModel.getR_email();
    String r_password = registrationModel.getR_password();
    String re_password = registrationModel.getRe_password();
    String name = registrationModel.getName();
    if (!Objects.equals(r_password, re_password)){
      return HttpStatus.BAD_REQUEST;
    }
    UserE u = new UserE();
    Role role = rolesRepository.findByName("ROLE_USER");
    u.setFirstName(name);
    u.setLastName(name);
    u.setUserName(r_email);
    u.setEmail(r_email);
    u.setPassword(r_password);
    u.setRoles(Collections.singletonList(role));
    userEntityRepository.save(u);
    return HttpStatus.ACCEPTED;
  }
}

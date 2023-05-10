package com.example.isys2101group15.controller;

import com.example.isys2101group15.entity.OrderEntity;
import com.example.isys2101group15.entity.Reservation;
import com.example.isys2101group15.entity.UserE;
import com.example.isys2101group15.repository.OrderRepository;
import com.example.isys2101group15.repository.ReservationRepository;
import com.example.isys2101group15.repository.UserEntityRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@CrossOrigin
@RequiredArgsConstructor
public class RestEndpoint {
  private final ReservationRepository reservationRepository;
  private final UserEntityRepository userEntityRepository;
  private final OrderRepository orderRepository;
  @GetMapping("/reservation/all")
  public Page<Reservation> allReservation(Pageable pageable)
  {
    return reservationRepository.findAll(pageable);
  }
  @GetMapping("/userEs/all")
  public Page<UserE> allUser(Pageable pageable)
  {
    return userEntityRepository.findAll(pageable);
  }
  @GetMapping("/orderEntities/all")
  public Page<OrderEntity> allOrder(Pageable pageable){
    return orderRepository.findAll(pageable);
  }
}

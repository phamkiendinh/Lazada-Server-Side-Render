package com.example.isys2101group15.controller;

import com.example.isys2101group15.entity.Reservation;
import com.example.isys2101group15.entity.RestaurantTable;
import com.example.isys2101group15.model.ReservationModel;
import com.example.isys2101group15.repository.ReservationRepository;
import com.example.isys2101group15.repository.RestaurantTableRepository;
import java.util.Optional;
import lombok.RequiredArgsConstructor;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/booking")
@CrossOrigin
@RequiredArgsConstructor
public class BookingController {
private final ReservationRepository reservationRepository;
//private final RestaurantRepository restaurantRepository;
private final RestaurantTableRepository restaurantTableRepository;
private static final Logger logger = LoggerFactory.getLogger(BookingController.class.getName());
@PostMapping(value = "/makeBooking",consumes = {MediaType.APPLICATION_FORM_URLENCODED_VALUE})
public ResponseEntity<String> makeBooking(@ModelAttribute ReservationModel reservationModel){
  Optional<RestaurantTable> restaurantTable = Optional.ofNullable(
      restaurantTableRepository.findByTableName(
          reservationModel.getTableID()));
  if (restaurantTable.isEmpty()){
    return new ResponseEntity<>("false", HttpStatus.OK);
  }
  if(
      reservationRepository.findAllByRestaurantTableAndTimeSlot(restaurantTable.get(), String.valueOf(reservationModel.getTime())) == null){
    Reservation r = new Reservation();
    r.setRestaurant(restaurantTable.get().getRestaurant());
    r.setRestaurantTable(restaurantTable.get());
    r.setTimeSlot(String.valueOf(reservationModel.getTime()));
    r.setEmail(reservationModel.getEmail());
    r.setPhoneNumber(reservationModel.getPhoneNumber());
    reservationRepository.save(r);
    return new ResponseEntity<>("true", HttpStatus.OK);
  }
  return new ResponseEntity<>("false", HttpStatus.OK);
}

}

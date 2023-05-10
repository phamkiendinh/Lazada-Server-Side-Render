package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.Reservation;
import com.example.isys2101group15.entity.RestaurantTable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.querydsl.QuerydslPredicateExecutor;

public interface ReservationRepository extends JpaRepository<Reservation, Long>,
    QuerydslPredicateExecutor<Reservation> {
    Reservation findAllByRestaurantTableAndTimeSlot(
        RestaurantTable restaurantTable, String timeSlot);
}
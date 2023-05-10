package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.Restaurant;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.querydsl.QuerydslPredicateExecutor;

public interface RestaurantRepository extends JpaRepository<Restaurant, Long>,
    JpaSpecificationExecutor<Restaurant>, QuerydslPredicateExecutor<Restaurant> {

}
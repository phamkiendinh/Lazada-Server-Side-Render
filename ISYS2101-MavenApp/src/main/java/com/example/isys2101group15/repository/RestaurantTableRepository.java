package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.RestaurantTable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.querydsl.QuerydslPredicateExecutor;

public interface RestaurantTableRepository extends JpaRepository<RestaurantTable, Long>,
    JpaSpecificationExecutor<RestaurantTable>, QuerydslPredicateExecutor<RestaurantTable> {
  @Query("select r from RestaurantTable r where r.tableName = concat('Table ',?1 ) ")
  RestaurantTable findByTableName(Long tableName);
}
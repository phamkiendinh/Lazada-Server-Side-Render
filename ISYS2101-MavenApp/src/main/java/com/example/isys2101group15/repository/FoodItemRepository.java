package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.FoodItem;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.querydsl.QuerydslPredicateExecutor;
import org.springframework.data.repository.query.Param;

public interface FoodItemRepository extends JpaRepository<FoodItem, Long>,
    QuerydslPredicateExecutor<FoodItem> {
  Page<FoodItem> findAllByCategory(String category, Pageable pageable);

  @Query(value = "select * from food_item"
      + " where to_tsvector('english',name) @@ to_tsquery('english', ?1)", nativeQuery = true)
  Page<FoodItem> searchFoodItemByName(@Param("name") String name, Pageable pageable);
}
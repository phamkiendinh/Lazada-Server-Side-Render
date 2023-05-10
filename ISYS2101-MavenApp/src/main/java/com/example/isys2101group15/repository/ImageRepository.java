package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.Image;
import java.util.Optional;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.querydsl.QuerydslPredicateExecutor;

public interface ImageRepository extends JpaRepository<Image, Long>, QuerydslPredicateExecutor<Image> {
  Optional<Image> findImageByName(String name);
}
package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.UserE;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.stereotype.Repository;

@Repository
public interface UserEntityRepository extends JpaRepository<UserE, Long>,
    JpaSpecificationExecutor<UserE> {
  UserE findByUserName(String username);
}
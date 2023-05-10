package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.Privilege;
import org.springframework.data.jpa.repository.JpaRepository;

public interface PrivilegesRepository extends JpaRepository<Privilege, Long> {
  Privilege findByName(String name);
}
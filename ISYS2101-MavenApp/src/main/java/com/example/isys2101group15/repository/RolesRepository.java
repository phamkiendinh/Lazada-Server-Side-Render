package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.Role;
import org.springframework.data.jpa.repository.JpaRepository;

public interface RolesRepository extends JpaRepository<Role, Long> {

  Role findByName(String name);
}
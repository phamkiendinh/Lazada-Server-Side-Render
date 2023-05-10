package com.example.isys2101group15.repository;

import com.example.isys2101group15.entity.Transaction;
import org.springframework.data.jpa.repository.JpaRepository;

public interface TransactionRepository extends JpaRepository<Transaction, Long> {

}
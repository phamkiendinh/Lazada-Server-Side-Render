package com.example.isys2101group15.entity;

import com.fasterxml.jackson.annotation.JsonIgnore;
import java.math.BigDecimal;
import java.time.ZonedDateTime;
import java.util.Collection;
import java.util.List;
import java.util.Set;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToMany;
import javax.persistence.ManyToOne;
import javax.persistence.Table;
import lombok.Getter;
import lombok.Setter;
import org.hibernate.annotations.Fetch;
import org.hibernate.annotations.FetchMode;

@Entity
@Table(name = "order_entity")
public class OrderEntity {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id", nullable = false)
  private Long id;

  public Long getId() {
    return id;
  }

  public void setId(Long id) {
    this.id = id;
  }
  @ManyToMany()
  @Getter
  @Setter
  private List<FoodItem> foodItems;
  @ManyToOne
  @Getter
  @Setter
  @JsonIgnore
  private UserE user;
  @Getter
  @Setter
  private BigDecimal totalCost;
  @Getter
  @Setter
  private String voucher, requirement;
  @Getter
  @Setter
  private String address;
  @Getter
  @Setter
  private boolean chiliSauce;
  @Getter
  @Setter
  private boolean ketchup;
  @Getter
  @Setter
  private boolean silverPaper;
  @Getter
  @Setter
  private boolean spoon;
  @Getter
  @Setter
  private ZonedDateTime orderCreationTime;
}
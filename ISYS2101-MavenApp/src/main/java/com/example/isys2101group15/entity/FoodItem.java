package com.example.isys2101group15.entity;

import com.fasterxml.jackson.annotation.JsonSetter;
import java.math.BigDecimal;
import java.util.Objects;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import org.hibernate.Hibernate;

@Entity
@NoArgsConstructor
@AllArgsConstructor
public class FoodItem {


  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id", nullable = false)
  @Setter
  @Getter
  private Long id;
  @Getter
  @Setter
  private String name, category,imgPath;
  @Setter
  @Getter
  @Column(columnDefinition="TEXT")
  private String description;
  @Getter
  @Setter
  private boolean isNew,recommended,openSpot;
  @ManyToOne
  @Getter
  @Setter
  private Restaurant restaurant;
  private BigDecimal price;

  public BigDecimal getPrice() {
    return price;
  }

  @JsonSetter
  public void setPrice(BigDecimal price) {
    this.price = price;
  }
  public void setPrice(String price){
    this.price = BigDecimal.valueOf(Double.parseDouble(price));
  }
  public void setPrice(Long price){
    this.price = BigDecimal.valueOf(price);
  }
  public void setPrice(int price){
    this.price = BigDecimal.valueOf(price);
  }
  public void setPrice(double price){
    this.price = BigDecimal.valueOf(price);
  }



  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || Hibernate.getClass(this) != Hibernate.getClass(o)) {
      return false;
    }
    FoodItem foodItem = (FoodItem) o;
    return id != null && Objects.equals(id, foodItem.id);
  }

  @Override
  public int hashCode() {
    return getClass().hashCode();
  }
}

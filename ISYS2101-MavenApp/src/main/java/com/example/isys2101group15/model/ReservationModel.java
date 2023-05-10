package com.example.isys2101group15.model;


import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import lombok.ToString;


@ToString
public class ReservationModel {
  private String name, email, phoneNumber;
  private int time;
  private long tableID, restaurantID;

  public String getName() {
    return name;
  }

  public void setName(String name) {
    this.name = name;
  }

  public String getEmail() {
    return email;
  }

  public void setEmail(String email) {
    this.email = email;
  }

  public String getPhoneNumber() {
    return phoneNumber;
  }

  public void setPhoneNumber(String phoneNumber) {
    this.phoneNumber = phoneNumber;
  }

  public int getTime() {
    return time;
  }

  public void setTime(int time) {
    this.time = time;
  }

  public long getTableID() {
    return tableID;
  }

  public void setTableID(long tableID) {
    this.tableID = tableID;
  }

  public long getRestaurantID() {
    return restaurantID;
  }

  public void setRestaurantID(long restaurantID) {
    this.restaurantID = restaurantID;
  }
}

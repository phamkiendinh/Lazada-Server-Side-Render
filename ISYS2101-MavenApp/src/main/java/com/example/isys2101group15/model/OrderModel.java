package com.example.isys2101group15.model;


import com.fasterxml.jackson.annotation.JsonFormat;
import java.util.List;
import lombok.Getter;
import lombok.RequiredArgsConstructor;
import lombok.Setter;

@Getter
@Setter
@RequiredArgsConstructor
public class OrderModel {
  @JsonFormat(with = JsonFormat.Feature.ACCEPT_SINGLE_VALUE_AS_ARRAY)
  private List<Long> itemList;
  private String requirement;
  private String voucher;
  private String address;
  private Boolean spoon;
  private Boolean ketchup;
  private Boolean chiliSauce;
  private Boolean silverPaper;
}

package com.example.isys2101group15.entity;

import java.util.Objects;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Lob;
import lombok.Getter;
import lombok.Setter;
import org.hibernate.Hibernate;

@Entity
public class Image {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id", nullable = false)
  private Long id;
  @Getter
  @Setter
  private String name;
  @Lob
  @Column(name = "img", columnDefinition = "bytea")
  @Getter
  @Setter
  private byte[] data;

  public Long getId() {
    return id;
  }

  public void setId(Long id) {
    this.id = id;
  }

  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || Hibernate.getClass(this) != Hibernate.getClass(o)) {
      return false;
    }
    Image image = (Image) o;
    return id != null && Objects.equals(id, image.id);
  }

  @Override
  public int hashCode() {
    return getClass().hashCode();
  }
}

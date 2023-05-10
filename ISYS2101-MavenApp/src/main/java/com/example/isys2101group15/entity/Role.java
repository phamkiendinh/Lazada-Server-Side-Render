package com.example.isys2101group15.entity;

import com.fasterxml.jackson.annotation.JsonBackReference;
import java.util.Collection;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.JoinTable;
import javax.persistence.ManyToMany;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.RequiredArgsConstructor;
import lombok.Setter;

@Entity
@NoArgsConstructor
public class Role {

  @Id
  @GeneratedValue(strategy = GenerationType.AUTO)
  @Column(name = "id", nullable = false)
  private Long id;

  public Role(String name) {
    this.name = name;
  }

  public Long getId() {
    return id;
  }
  public void setId(Long id) {
    this.id = id;
  }
  @Getter
  @Setter
  private String name;
  @ManyToMany
  @JsonBackReference
  private Collection<UserE> users;
  @ManyToMany(fetch = FetchType.EAGER)
  @Setter
  @Getter
  @JoinTable(
      name = "roles_privileges",
      joinColumns = @JoinColumn(
          name = "role_id", referencedColumnName = "id"),
      inverseJoinColumns = @JoinColumn(
          name = "privileges_id", referencedColumnName = "id"))
  private Collection<Privilege> privileges;
}

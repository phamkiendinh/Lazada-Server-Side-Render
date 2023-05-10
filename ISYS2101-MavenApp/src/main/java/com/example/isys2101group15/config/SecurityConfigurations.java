package com.example.isys2101group15.config;

import com.example.isys2101group15.repository.RolesRepository;
import com.example.isys2101group15.repository.UserEntityRepository;
import com.example.isys2101group15.service.CustomUserDetailService;
import java.util.HashMap;
import java.util.Map;
import lombok.RequiredArgsConstructor;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.factory.PasswordEncoderFactories;
import org.springframework.security.crypto.password.DelegatingPasswordEncoder;
import org.springframework.security.crypto.password.NoOpPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.crypto.password.Pbkdf2PasswordEncoder;
import org.springframework.security.crypto.password.StandardPasswordEncoder;
import org.springframework.security.crypto.scrypt.SCryptPasswordEncoder;
import org.springframework.security.web.SecurityFilterChain;

@EnableWebSecurity
@Configuration
@RequiredArgsConstructor
public class SecurityConfigurations {
  private final UserEntityRepository userEntityRepository;

  private final RolesRepository rolesRepository;
  @Bean
  public PasswordEncoder passwordEncoder(){
    return new BCryptPasswordEncoder();
  }
  @Bean
  public UserDetailsService userDetailsService(){
    return new CustomUserDetailService(userEntityRepository,rolesRepository);
  }

  @Bean
  public SecurityFilterChain filterChain(HttpSecurity http) throws Exception {
    http
        .authorizeRequests()
        .antMatchers("/api-docs","/swagger-ui/**", "/v3/api-docs/**","/v3/**").permitAll()
        .antMatchers("/css/**","/image/**","/js/**").permitAll()
        .antMatchers("/food").permitAll()
        .antMatchers("/img/**").permitAll()
        .antMatchers("/login").permitAll()
        .antMatchers("/register/**").permitAll()
        .antMatchers("/delivery/checkout/**","/order/**","/cart").authenticated()
        .antMatchers("/users/**", "/settings/**","/admin/**").hasAnyAuthority("WRITE_PRIVILEGE")
        .anyRequest().permitAll()
        .and()
        .formLogin(form-> form
            .loginPage("/login")
            .loginProcessingUrl("/login")
            .usernameParameter("email")
            .passwordParameter("password")
            .permitAll())
        .logout(logout->
            logout.logoutUrl("/logout")
        .deleteCookies("JSESSIONID"))
        .csrf().disable();
    http.authenticationProvider(authenticationProvider());
    return http.build();
  }
  @Bean
  public DaoAuthenticationProvider authenticationProvider(){
    DaoAuthenticationProvider authenticationProvider = new DaoAuthenticationProvider();
    authenticationProvider.setUserDetailsService(userDetailsService());
    authenticationProvider.setPasswordEncoder(passwordEncoder());
    return authenticationProvider;
  }
//  @Bean
//  public DefaultWebSecurityExpressionHandler webSecurityExpressionHandler() {
//    DefaultWebSecurityExpressionHandler expressionHandler = new DefaultWebSecurityExpressionHandler();
//    expressionHandler.setRoleHierarchy(roleHierarchy());
//    return expressionHandler;
//  }
//  @Bean
//  public RoleHierarchy roleHierarchy() {
//    RoleHierarchyImpl roleHierarchy = new RoleHierarchyImpl();
//    String hierarchy = "ROLE_ADMIN > ROLE_STAFF \n ROLE_STAFF > ROLE_USER";
//    roleHierarchy.setHierarchy(hierarchy);
//    return roleHierarchy;
//  }
}

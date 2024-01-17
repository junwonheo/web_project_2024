package com.example.codesnack.users;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import lombok.Data;

@Entity
@Data
public class User {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "userId")
    private Long userId;

    @Column(name = "userName")
    private String userName;

    @Column(name = "id")
    private String id;

    @Column(name = "passwd")
    private String passwd;

    @Column(name = "nickname")
    private String nickname;

    @Column(name = "question")
    private Long question;

    @Column(name = "answer")
    private String answer;
}

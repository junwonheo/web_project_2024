package com.example.codesnack.notices;

import com.example.codesnack.users.User;
import jakarta.persistence.*;
import lombok.Data;

import java.sql.Timestamp;

@Entity
@Data
public class Notice {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "noticeId")
    private Long noticeId;

    @Column(name = "title")
    private String title;

    @Column(name = "content")
    private String content;

    @Column(name = "timestamp")
    private Timestamp timestamp;
}

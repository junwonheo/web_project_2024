package com.example.codesnack.posts;

import com.example.codesnack.users.User;
import jakarta.persistence.*;
import lombok.Data;

import java.sql.Timestamp;

@Entity
@Data
public class Post {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "postId")
    private Long postId;

    @ManyToOne
    @JoinColumn(name = "userId")
    private User user;

    @Column(name = "postType")
    private Long postType;

    @Column(name = "title")
    private String title;

    @Column(name = "content")
    private String content;

    @Column(name = "image")
    private String image;

    @Column(name = "timestamp")
    private Timestamp timestamp;
}

package com.example.codesnack.comments;

import com.example.codesnack.posts.Post;
import com.example.codesnack.users.User;
import jakarta.persistence.*;
import lombok.Data;

import java.sql.Timestamp;

@Entity
@Data
public class Comment {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "commentID")
    private Long commentId;

    @ManyToOne
    @JoinColumn(name = "userID")
    private User user;

    @ManyToOne
    @JoinColumn(name = "postID")
    private Post post;

    @Column(name = "content")
    private String content;

    @Column(name = "timestamp")
    private Timestamp timestamp;
}
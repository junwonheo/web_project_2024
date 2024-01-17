package com.example.codesnack.posts;

import com.example.codesnack.users.User;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.sql.Timestamp;

@Data
@NoArgsConstructor
public class PostDTO {
    private Long postId;
    private User user;
    private Long postType;
    private String title;
    private String content;
    private String image;
    private Timestamp timestamp;
}

package com.example.codesnack.posts;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.sql.Timestamp;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class PostDTO {

    private Long postId;
    private Long userId;
    private int posttype;
    private String title;
    private String content;
    private String image;
    private Timestamp timestamp;
}
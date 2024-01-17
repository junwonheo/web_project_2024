package com.example.codesnack.comments;

import com.example.codesnack.posts.Post;
import com.example.codesnack.users.User;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.sql.Timestamp;

@Data
@NoArgsConstructor
public class CommentDTO {
    private Long commentId;
    private User user;
    private Post post;
    private String content;
    private Timestamp timestamp;
}

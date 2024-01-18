package com.example.codesnack.comments;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.sql.Timestamp;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class CommentDTO {

    private Long commentId;
    private Long userId;
    private Long postId;
    private String comment;
    private Timestamp timestamp;
}
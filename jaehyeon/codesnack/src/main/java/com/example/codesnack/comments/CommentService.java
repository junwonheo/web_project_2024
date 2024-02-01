package com.example.codesnack.comments;

import java.util.Optional;

public interface CommentService {
    Optional<Comment> saveComment(Long postId, CommentDTO commentDTO);
}

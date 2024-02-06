package com.example.codesnack.comments;

import com.example.codesnack.posts.Post;

import java.util.List;
import java.util.Optional;

public interface CommentService {
    Optional<Comment> saveComment(Long postId, CommentDTO commentDTO);
    Post getCurrentPostFromPostId(Long postId);
    Optional<List<Comment>> getCommentByPostId(Long postId);
}

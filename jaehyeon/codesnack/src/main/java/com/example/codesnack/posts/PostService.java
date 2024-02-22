package com.example.codesnack.posts;

import org.springframework.data.domain.Page;

import java.util.List;
import java.util.Optional;

public interface PostService {
    Optional<Post> savePost(PostDTO postDTO);

    public Page<Post> getPostsByUserId(int posttype, int page, int size);

    public Post getPost(Long postId);

    Page<Post> searchPosts(String keyword, int page, int size);
}

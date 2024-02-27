package com.example.codesnack.posts;

import org.springframework.data.domain.Page;

import java.util.List;
import java.util.Optional;

public interface PostService {
    Optional<Post> savePost(PostDTO postDTO);

     Page<Post> getPostsByUserId(int posttype, int page, int size);

     Post getPost(Long postId);

    List<Post> getAllPosts();

    List<Post> searchPosts(String keyword);
}

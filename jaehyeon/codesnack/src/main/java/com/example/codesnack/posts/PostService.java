package com.example.codesnack.posts;

import java.util.List;
import java.util.Optional;

public interface PostService {
    Optional<Post> savePost(PostDTO postDTO);
    Optional<List<Post>> getLatestPosts(long postId, int count, int page);
}

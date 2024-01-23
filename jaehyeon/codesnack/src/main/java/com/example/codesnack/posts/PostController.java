package com.example.codesnack.posts;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api/board")
public class PostController {
    private final PostService postService;

    @Autowired
    public PostController(PostService postService) {
        this.postService = postService;
    }

    @PostMapping("/post")
    public ResponseEntity<Post> createPost(@RequestBody PostDTO postDTO) {
        return postService.savePost(postDTO)
                .map(post -> ResponseEntity.ok().body(post))
                .orElse(ResponseEntity.badRequest().build());
    }

}

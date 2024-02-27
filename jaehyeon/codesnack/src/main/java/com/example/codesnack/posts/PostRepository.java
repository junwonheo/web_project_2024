package com.example.codesnack.posts;

import org.springframework.data.domain.Page;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import org.springframework.data.domain.Pageable;

import java.util.List;
import java.util.Optional;

@Repository
public interface PostRepository extends JpaRepository<Post, Long> {
    Page<Post> findAllByPosttypeOrderByTimestampDesc(int posttype, Pageable pageable);
    Optional<Post> findByPostId(long postId);
    List<Post> findByTitleContainingIgnoreCase(String keyword);
}

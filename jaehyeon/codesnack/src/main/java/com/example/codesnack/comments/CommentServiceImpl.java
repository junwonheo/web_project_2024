package com.example.codesnack.comments;

import com.example.codesnack.posts.Post;
import com.example.codesnack.posts.PostRepository;
import com.example.codesnack.users.User;
import com.example.codesnack.users.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpSession;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.sql.Timestamp;
import java.util.List;
import java.util.Optional;

@Service
public class CommentServiceImpl implements CommentService {
    private final CommentRepository commentRepository;
    private final PostRepository postRepository;
    private final UserService userService;
    private final HttpServletRequest request;

    @Autowired
    public CommentServiceImpl(
        CommentRepository commentRepository,
        PostRepository postRepository,
        UserService userService,
        HttpServletRequest request
    ) {
        this.commentRepository = commentRepository;
        this.postRepository = postRepository;
        this.userService = userService;
        this.request = request;
    }

    public Optional<Comment> saveComment(Long postId, CommentDTO commentDTO) {
        User user = getCurrentUserFromSession();
        Post post = getCurrentPostFromPostId(postId);

        Comment comment = new Comment();
        comment.setUserId(user.getUserId());
        comment.setPostId(postId);
        comment.setComment(commentDTO.getComment());
        comment.setTimestamp(new Timestamp(System.currentTimeMillis()));
        comment.setPost(post);

        return Optional.ofNullable(commentRepository.save(comment));
    }

    private User getCurrentUserFromSession() {
        HttpSession session = request.getSession(false);
        // 세션에 사용자 정보가 없으면 예외 처리 또는 기본값 반환
        if (session != null) {
            String nickname = (String) session.getAttribute("user");
            if (nickname != null) {
                return userService.getUserByNickname(nickname);
            }
        }
        return null;
    }

    @Override
    public Post getCurrentPostFromPostId(Long postId) {
        return postRepository.findByPostId(postId).orElse(null);
    }

    @Override
    public Optional<List<Comment>> getCommentByPostId(Long postId) {
        return commentRepository.findAllByPostId(postId);
    }
}

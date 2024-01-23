package com.example.codesnack.posts;

import com.example.codesnack.users.User;
import com.example.codesnack.users.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpSession;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Service;

import java.sql.Timestamp;
import java.util.List;
import java.util.Optional;

@Service
public class PostServiceImpl implements PostService {
    private final PostRepository postRepository;
    private final UserService userService;
    private final HttpServletRequest request;

    @Autowired
    public PostServiceImpl(
        PostRepository postRepository,
        UserService userService,
        HttpServletRequest request
    ) {
        this.postRepository = postRepository;
        this.userService = userService;
        this.request = request;
    }


    @Override
    public Optional<Post> savePost(PostDTO postDTO) {
        Post post = new Post();

        User user = getCurrentUserFromSession();
        post.setUser(user);

        post.setPosttype(post.getPosttype());
        post.setTitle(postDTO.getTitle());
        post.setContent(postDTO.getContent());
        post.setImage(postDTO.getImage());

        Timestamp timestamp = new Timestamp(System.currentTimeMillis());
        post.setTimestamp(timestamp);

        return Optional.ofNullable(postRepository.save(post));
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
    public Optional<List<Post>> getLatestPosts(long postId, int count, int page) {
        Sort sort = Sort.by(Sort.Direction.DESC, "timestamp");
        Pageable pageable = PageRequest.of(page, count, sort);
        Page<Post> postPage = postRepository.findByPostIdOrderByTimestampDesc(postId, pageable);

        List<Post> latestPosts = postPage.getContent();

        return Optional.ofNullable(latestPosts.isEmpty() ? null : latestPosts);
    }

}

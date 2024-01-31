package com.example.codesnack.posts;

import com.example.codesnack.DataNotFoundException;
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

        post.setPosttype(postDTO.getPosttype());
        post.setTitle(postDTO.getTitle());
        post.setContent(postDTO.getContent());

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
    public Page<Post> getPostsByUserId(int posttype, int page, int size) {
        Pageable pageable = PageRequest.of(page, size, Sort.by("timestamp").descending());
        return postRepository.findAllByPosttypeOrderByTimestampDesc(posttype, pageable);
    }


    @Override
    public Post getPost(Long postId) {
        Optional<Post> post = this.postRepository.findByPostId(postId);

        if(post.isPresent()) {
            return post.get();
        }
        else {
            throw new DataNotFoundException("question not found");
        }
    }
}

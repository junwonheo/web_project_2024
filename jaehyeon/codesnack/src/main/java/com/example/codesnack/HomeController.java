package com.example.codesnack;

import com.example.codesnack.comments.Comment;
import com.example.codesnack.comments.CommentService;
import com.example.codesnack.notices.NoticeService;
import com.example.codesnack.posts.Post;
import com.example.codesnack.posts.PostService;
import com.example.codesnack.users.UserService;
import jakarta.servlet.http.HttpSession;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.Collections;
import java.util.List;
import java.util.Optional;

@Controller
@RequiredArgsConstructor
public class HomeController {
    private final PostService postService;
    private final NoticeService noticeService;
    private final CommentService commentService;
    private final UserService userService;

    @GetMapping("/")
    public String home() {
        return "index";
    }

    @GetMapping("/register")
    public String register() {
        return "register";
    }

    @GetMapping("/noticeBoard")
    public String showNoticeBoard(Model model) {
        model.addAttribute("latestNoticeBoardPosts", noticeService.getLatestNoticeBoardPosts(0, 10));
        return "notice-board";
    }

    @GetMapping("/freeBoard")
    public String showFreeBoard(Model model) {
        model.addAttribute("latestFreeBoardPosts", postService.getPostsByUserId(1, 0, 10));
        return "free-board";
    }

    @GetMapping("/marketBoard")
    public String showMarketBoard(Model model) {
        model.addAttribute("latestMarketBoardPosts", postService.getPostsByUserId(2, 0, 10));
        return "market-board";
    }

    @GetMapping("/suggestionsBoard")
    public String showSuggestionsBoard(Model model) {
        model.addAttribute("latestSuggestionsBoardPosts", postService.getPostsByUserId(3, 0, 10));
        return "suggestions-board";
    }

    @GetMapping("/qnaBoard")
    public String showQnaBoard(Model model) {
        model.addAttribute("latestQnaBoardPosts", postService.getPostsByUserId(4, 0, 10));
        return "qna-board";
    }

    @GetMapping(value = "/post/detail/{postId}")
    public String detail(Model model, @PathVariable("postId") Long postId) {
        Post post = this.postService.getPost(postId);
        model.addAttribute("post", post);

        Optional<List<Comment>> commentsOptional = commentService.getCommentByPostId(postId);

        if (commentsOptional.isPresent()) {
            List<Comment> comments = commentsOptional.get();
            model.addAttribute("Comments", comments);
        } else {

            model.addAttribute("Comments", Collections.emptyList());
        }

        return "post-detail";
    }

    @GetMapping("/pointShop")
    public String showPointShop(Model model) {
        int point = this.userService.getPoint();
        model.addAttribute("point", point);
        return "pointshop";
    }

    @PostMapping("/pointShop/updateNickname")
    public String updateNickname(@RequestParam(name = "newNickname", required = true) String newNickname, HttpSession session) {
        userService.updateCurrentSessionNickname(newNickname);
        session.invalidate();
        return "index";
    }

    @GetMapping("/writePostPage")
    public String showWritePostPage() {
        return "write-post-page";
    }

    @GetMapping("/writeNoticePage")
    public String showWriteNoticePage() {
        return "write-notice-page";
    }

    @GetMapping("/findIdPage")
    public String showFindIdPage() {
        return "find-id";
    }

    @GetMapping("/passwordResetPage")
    public String showFindPwPage() {
        return "find-pw";
    }

    @GetMapping("/search")
    public String searchPosts(@RequestParam(name = "q", required = false) String q, Model model) {
        List<Post> posts;
        if (q != null && !q.isEmpty()) {
            // 검색어가 있을 경우 검색 수행
            posts = postService.searchPosts(q);
        } else {
            // 검색어가 없을 경우 모든 게시글 조회
            posts = postService.getAllPosts();
        }

        model.addAttribute("searchResults", posts);
        return "search-page";
    }


    @PostMapping("/findId")
    public String findUsername(@RequestParam("username") String username,
                               @RequestParam("nickname") String nickname,
                               Model model) {
        String foundUsername = userService.findUsername(username, nickname);

        if (foundUsername != null) {
            model.addAttribute("foundUsername", foundUsername);
            return "/findUsernameResult";
        } else {
            model.addAttribute("message", "해당하는 아이디를 찾을 수 없습니다.");
            return "redirect:/findUsernameFail";
        }
    }

    @PostMapping("/resetPassword")
    public String resetPassword(@RequestParam("id") String id,
                                @RequestParam("username") String username,
                                @RequestParam("question") int question,
                                @RequestParam("answer") String answer,
                                @RequestParam("password") String password,
                                @RequestParam("password_re") String passwordRe,
                                Model model) {

        if (userService.resetPassword(id, username, question, answer, password, passwordRe)) {
            model.addAttribute("message", "비밀번호가 성공적으로 변경되었습니다.");
            return "/findPwResult";
        } else {
            model.addAttribute("message", "비밀번호 변경에 실패하였습니다.");
            return "redirect:/resetPasswordFail";
        }
    }
}

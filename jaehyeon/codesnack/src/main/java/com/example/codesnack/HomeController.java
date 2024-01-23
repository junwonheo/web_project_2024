package com.example.codesnack;

import com.example.codesnack.posts.PostService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class HomeController {
    private final PostService postService;

    @Autowired
    public HomeController(PostService postService) {
        this.postService = postService;
    }

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
        model.addAttribute("latestNoticePosts", postService.getLatestPosts(1, 30, 1).orElse(null));
        return "notice-board";
    }

    @GetMapping("/freeBoard")
    public String showFreeBoard(Model model) {
        model.addAttribute("latestFreeBoardPosts", postService.getLatestPosts(2, 30, 2).orElse(null));
        return "free-board";
    }

    @GetMapping("/marketBoard")
    public String showMarketBoard(Model model) {
        model.addAttribute("latestMarketBoardPosts", postService.getLatestPosts(3, 30, 3).orElse(null));
        return "market-board";
    }

    @GetMapping("/suggestionsBoard")
    public String showSuggestionsBoard(Model model) {
        model.addAttribute("latestSuggestionsBoardPosts", postService.getLatestPosts(4, 30, 4).orElse(null));
        return "suggestions-board";
    }

    @GetMapping("/qnaBoard")
    public String showQnaBoard(Model model) {
        model.addAttribute("latestQnaBoardsPosts", postService.getLatestPosts(5, 30, 5).orElse(null));
        return "qna-board";
    }

    @GetMapping("/pointShop")
    public String showPointShop() {
        return "pointshop";
    }

    @GetMapping("/writePostPage")
    public String showWritePostPage() {
        return "write-post-page";
    }
}

package com.example.codesnack;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class HomeController {

    @GetMapping("/")
    public String home() {
        return "index";
    }

    @GetMapping("/login")
    public String login() {
        return "login";
    }

    @GetMapping("/register")
    public String register() {
        return "register";
    }

    @GetMapping("/noticeBoard")
    public String showNoticeBoard() {
        return "notice-board";
    }

    @GetMapping("/freeBoard")
    public String showFreeBoard() {
        return "free-board";
    }

    @GetMapping("/marketBoard")
    public String showMarketBoard() {
        return "market-board";
    }

    @GetMapping("/suggestionsBoard")
    public String showSuggestionsBoard() {
        return "suggestions-board";
    }

    @GetMapping("/qnaBoard")
    public String showQnaBoard() {
        return "qna-board";
    }

    @GetMapping("/pointShop")
    public String showPointShop() {
        return "pointshop";
    }
}

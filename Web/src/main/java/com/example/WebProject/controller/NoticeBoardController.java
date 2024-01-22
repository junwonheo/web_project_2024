package com.example.WebProject.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class NoticeBoardController {
    @GetMapping("/notice-board")
    public String newnoticeboardForm(){
        return "notice-board";
    }
}

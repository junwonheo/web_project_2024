package com.example.WebProject.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class QnaBoardController {
    @GetMapping("/qna-board")
    public String newQnaBoardForm(){
        return "qna-board";
    }
}

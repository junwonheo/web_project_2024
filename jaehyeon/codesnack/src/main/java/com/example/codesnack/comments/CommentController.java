package com.example.codesnack.comments;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

@Controller
@RequestMapping("/api/comment")
public class CommentController {
    private final CommentService commentService;

    @Autowired
    public CommentController(CommentService commentService) {
        this.commentService = commentService;
    }

    @PostMapping("/{postId}")
    public String createComment(
            @PathVariable Long postId,
            @ModelAttribute CommentDTO commentDTO,
            Model model
    ) {
        commentService.saveComment(postId, commentDTO);
        model.addAttribute("message", "댓글 등록이 완료되었습니다.");
        return "redirect:/post/detail/" + postId;
    }
}

package com.example.codesnack.notices;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api/board")
public class NoticeController {
    private final NoticeService noticeService;

    @Autowired
    public NoticeController(NoticeService noticeService) {
        this.noticeService = noticeService;
    }

    @PostMapping("/notice")
    public ResponseEntity<Notice> createPost(@RequestBody NoticeDTO noticeDTO) {
        return noticeService.saveNotice(noticeDTO)
                .map(post -> ResponseEntity.ok().body(post))
                .orElse(ResponseEntity.badRequest().build());
    }
}

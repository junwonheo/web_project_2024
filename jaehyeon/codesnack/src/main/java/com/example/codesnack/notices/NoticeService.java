package com.example.codesnack.notices;

import org.springframework.data.domain.Page;

import java.util.Optional;

public interface NoticeService {
    Optional<Notice> saveNotice(NoticeDTO noticeDTO);
    public Page<Notice> getLatestNoticeBoardPosts(int page, int size);
}

package com.example.codesnack.notices;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Service;

import java.sql.Timestamp;
import java.util.Optional;

@Service
public class NoticeServiceImpl implements NoticeService {
    private final NoticeRepository noticeRepository;

    @Autowired
    public NoticeServiceImpl(NoticeRepository noticeRepository) {
        this.noticeRepository = noticeRepository;
    }
    @Override
    public Optional<Notice> saveNotice(NoticeDTO noticeDTO) {

        Notice notice = new Notice();

        notice.setTitle(noticeDTO.getTitle());
        notice.setContent(noticeDTO.getContent());

        Timestamp timestamp = new Timestamp(System.currentTimeMillis());
        notice.setTimestamp(timestamp);

        return Optional.ofNullable(noticeRepository.save(notice));
    }


    @Override
    public Page<Notice> getLatestNoticeBoardPosts(int page, int size) {
        Pageable pageable = PageRequest.of(page, size, Sort.by("timestamp").descending());
        return noticeRepository.findAll(pageable);
    }
}

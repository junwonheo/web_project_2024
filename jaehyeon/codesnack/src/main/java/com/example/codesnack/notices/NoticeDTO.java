package com.example.codesnack.notices;

import lombok.Data;
import lombok.NoArgsConstructor;

import java.sql.Timestamp;

@Data
@NoArgsConstructor
public class NoticeDTO {
    private Long noticeId;
    private String title;
    private String content;
    private Timestamp timestamp;
}

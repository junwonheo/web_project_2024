package com.example.codesnack.notices;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.sql.Timestamp;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class NoticeDTO {

    private Long noticeId;
    private String title;
    private String content;
    private Timestamp timestamp;
}
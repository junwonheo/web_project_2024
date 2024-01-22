package com.example.WebProject.dto;

import com.example.WebProject.entity.Free;
import lombok.AllArgsConstructor;
import lombok.ToString;

@AllArgsConstructor
@ToString
public class FreeBoardForm {
    private String title;
    private String content;


    public Free toEntity() {
        return new Free(null, title, content);
    }
}

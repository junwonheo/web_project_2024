package com.example.codesnack.users;

import lombok.*;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class UserDTO {

    private Long userId;
    private String username;
    private String id;
    private String passwd;
    private String nickname;
    private int question;
    private String answer;
    private int point;
}

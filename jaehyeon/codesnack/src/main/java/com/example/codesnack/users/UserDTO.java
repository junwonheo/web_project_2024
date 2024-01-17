package com.example.codesnack.users;

import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class UserDTO {
    private Long userId;
    private String userName;
    private String id;
    private String passwd;
    private String nickname;
    private Long question;
    private String answer;
}

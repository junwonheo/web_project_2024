package com.example.codesnack.users;

import java.util.Optional;

public interface UserService {
    Optional<User> saveUser(UserDTO userDTO);
    int getPoint();
    Optional<User> getUserById(Long userId);
    User authenticateUser(UserDTO userDTO);

    User getUserByNickname(String nickname);

    Optional<User> updateCurrentSessionNickname(String nickname);

    boolean isIdUnique(String id);

    boolean isNicknameUnique(String nickname);

    String findUsername(String username, String nickname);

    boolean resetPassword(String userId, String username, int question, String answer, String password, String passwordRe);
}

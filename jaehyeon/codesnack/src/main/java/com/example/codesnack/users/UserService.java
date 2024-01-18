package com.example.codesnack.users;

import java.util.Optional;

public interface UserService {
    Optional<User> saveUser(UserDTO userDTO);
    Optional<User> getUserById(Long userId);
    User authenticateUser(UserDTO userDTO);

    User getUserByNickname(String nickname);

    public boolean isIdUnique(String id);

    public boolean isNicknameUnique(String nickname);

}

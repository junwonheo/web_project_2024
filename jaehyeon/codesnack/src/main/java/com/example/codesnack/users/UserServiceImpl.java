package com.example.codesnack.users;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Optional;

@Service
public class UserServiceImpl implements UserService {
    private final UserRepository userRepository;

    @Autowired
    public UserServiceImpl(UserRepository userRepository) {
        this.userRepository = userRepository;
    }

    @Override
    public Optional<User> saveUser(UserDTO userDTO) {
        // UserDTO에서 User 엔티티로 변환
        User user = new User();
        user.setUserId(user.getUserId());
        user.setUsername(userDTO.getUsername());
        user.setId(userDTO.getId());
        user.setPasswd(userDTO.getPasswd());
        user.setNickname(userDTO.getNickname());
        user.setQuestion(userDTO.getQuestion());
        user.setAnswer(userDTO.getAnswer());

        // User 엔티티 저장
        return Optional.ofNullable(userRepository.save(user));
    }

    @Override
    public Optional<User> getUserById(Long userId) {
        // 사용자 ID로 사용자 조회
        return userRepository.findById(userId);
    }

    @Override
    public User authenticateUser(UserDTO userDTO) {
        String id = userDTO.getId();
        String passwd = userDTO.getPasswd();

        User user = userRepository.findByIdAndPasswd(id, passwd);
        return user;
    }

    @Override
    public User getUserByNickname(String nickname) {
        return userRepository.findByNickname(nickname).orElse(null);
    }

    @Override
    public boolean isIdUnique(String id) {
        return !userRepository.findById(id).isPresent();
    }


    @Override
    public boolean isNicknameUnique(String nickname) {
        return !userRepository.findByNickname(nickname).isPresent();
    }
}

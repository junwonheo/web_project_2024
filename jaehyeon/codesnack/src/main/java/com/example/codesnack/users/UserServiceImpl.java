package com.example.codesnack.users;

import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpSession;
import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Optional;

@Service
@RequiredArgsConstructor
public class UserServiceImpl implements UserService {
    private final UserRepository userRepository;
    private final HttpServletRequest request;
    private final int DEFAULT_POINT = 500;

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
        user.setPoint(DEFAULT_POINT);

        // User 엔티티 저장
        return Optional.ofNullable(userRepository.save(user));
    }

    @Override
    public int getPoint() {
        User user = getCurrentUserFromSession();
        return user.getPoint();
    }

    private User getCurrentUserFromSession() {
        HttpSession session = request.getSession(false);
        // 세션에 사용자 정보가 없으면 예외 처리 또는 기본값 반환
        if (session != null) {
            String nickname = (String) session.getAttribute("user");
            if (nickname != null) {
                return getUserByNickname(nickname);
            }
        }
        return null;
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
    public Optional<User> updateCurrentSessionNickname(String nickname) {
        User user = getCurrentUserFromSession();

        if (user != null && user.getPoint() >= 100) {
            user.setPoint(user.getPoint() - 100);
            user.setNickname(nickname);
            return Optional.of(userRepository.save(user));
        } else {
            return Optional.empty();
        }
    }

    @Override
    public boolean isIdUnique(String id) {
        return !userRepository.findById(id).isPresent();
    }


    @Override
    public boolean isNicknameUnique(String nickname) {
        return !userRepository.findByNickname(nickname).isPresent();
    }


    @Override
    public String findUsername(String username, String nickname) {
        Optional<User> userOptional = userRepository.findByUsernameAndNickname(username, nickname);

        return userOptional.map(User::getId).orElse(null);
    }

    public boolean resetPassword(String id, String username, int question, String answer, String password, String passwordRe) {
        Optional<User> optionalUser = userRepository.findByIdAndUsernameAndQuestionAndAnswer(id, username, question, answer);

        if (optionalUser.isPresent() && password.equals(passwordRe)) {
            User user = optionalUser.get();
            user.setPasswd(password);
            userRepository.save(user);
            return true;
        }
        return false;
    }
}

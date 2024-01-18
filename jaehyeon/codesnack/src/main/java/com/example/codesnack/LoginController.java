package com.example.codesnack;

import com.example.codesnack.users.User;
import com.example.codesnack.users.UserDTO;
import com.example.codesnack.users.UserService;
import jakarta.servlet.http.HttpSession;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;

@Controller
public class LoginController {

    private final UserService userService;

    @Autowired
    public LoginController(UserService userService) {
        this.userService = userService;
    }

    @GetMapping("/login")
    public String login() {
        return "login";
    }

    @PostMapping("/login")
    public String login(UserDTO userDTO, Model model, HttpSession session) {
        User user = userService.authenticateUser(userDTO);

        if (user != null) {
            session.setAttribute("user", user.getNickname()); // 세션에도 사용자 정보 추가
            return "redirect:/";
        } else {
            model.addAttribute("loginSuccess", false);
            return "login";
        }
    }

    @GetMapping("/logout")
    public String logout(HttpSession session) {
        // 세션을 무효화하고 로그아웃
        session.invalidate();

        // 로그아웃이 완료되면 홈페이지로 리다이렉트
        return "redirect:/";
    }



}

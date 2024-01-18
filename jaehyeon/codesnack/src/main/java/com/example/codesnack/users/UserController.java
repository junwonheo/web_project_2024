package com.example.codesnack.users;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

@Controller
@RequestMapping("/api/users")
public class UserController {

    private final UserService userService;

    @Autowired
    public UserController(UserService userService) {
        this.userService = userService;
    }

    @GetMapping("/checkIdDuplicate")
    public ResponseEntity<Boolean> checkIdDuplicate(@RequestParam("id") String id) {
        boolean isUnique = userService.isIdUnique(id);
        return new ResponseEntity<>(isUnique, HttpStatus.OK);
    }

    @GetMapping("/checkNicknameDuplicate")
    public ResponseEntity<Boolean> checkNicknameDuplicate(@RequestParam("nickname") String nickname) {
        boolean isUnique = userService.isNicknameUnique(nickname);
        return new ResponseEntity<>(isUnique, HttpStatus.OK);
    }

    @PostMapping("/signup")
    public String signUp(@ModelAttribute UserDTO userDTO, Model model) {
        if (userService.isIdUnique(userDTO.getId()) && userService.isNicknameUnique(userDTO.getNickname())) {
            userService.saveUser(userDTO);
            model.addAttribute("message", "회원가입이 성공적으로 완료되었습니다.");
            return "redirect:/";
        } else {
            model.addAttribute("message", "회원가입에 실패하였습니다.");
            return "join";
        }
    }

    @GetMapping("/{userId}")
    public ResponseEntity<User> getUserById(@PathVariable Long userId) {
        return userService.getUserById(userId)
                .map(user -> ResponseEntity.ok().body(user))
                .orElse(ResponseEntity.notFound().build());
    }
}
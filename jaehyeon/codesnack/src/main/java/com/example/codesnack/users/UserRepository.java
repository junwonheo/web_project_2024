package com.example.codesnack.users;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface UserRepository extends JpaRepository<User, Long> {
    User findByIdAndPasswd(String id, String passwd);
    Optional<User> findByNickname(String nickname);

    Optional<User> findById(String id);
}

package com.example.WebProject.controller;

import com.example.WebProject.dto.FreeBoardForm;
import com.example.WebProject.entity.Free;
import com.example.WebProject.repository.FreeRepository;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;

@Slf4j
@Controller
public class FreeBoardController {
    @Autowired
    private FreeRepository freeRepository;

    @GetMapping("/write-post-page")
    public String newQnaBoardForm(){
        return "write-post-page";
    }

    @PostMapping("/freeBoard")
    public String creatWrite(FreeBoardForm form){
        log.info(form.toString());
        Free free =form.toEntity();
        log.info(free.toString());
        Free saved=freeRepository.save(free);
        log.info(saved.toString());
        return "free-board";
    }

    @GetMapping("/freeBoard/{id}")
    public String show(@PathVariable Long id, Model model){
        log.info("id = "+id);
        Free freeEntity=freeRepository.findById(id).orElse(null);
        model.addAttribute("free", freeEntity);
        return "free-board";
    }
}


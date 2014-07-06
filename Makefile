EXES= door doorgroup usercard floor
CFLAGS= -Wall -Wextra -ansi -pedantic
OFLAGS= -Wall -Wextra

.SUFFIXES:

.PHONY: all
all: $(EXES)

%.o: %.c
	@gcc -c $(CFLAGS) $<

$(EXES):
	@make $@.o
	@gcc -o $@ $(OFLAGS) $@.o

.PHONY: clean
clean: FORCE
	rm -f a.out *.o $(EXES)

.PHONY: FORCE
FORCE:


#include <stdio.h>

#define BUF_SIZE 6000

int main(int argc, char *argv[])
{
  FILE *fp;
  char door[BUF_SIZE];
  size_t count;
  int signed_count;
  int i;

  for (i = 0;i < BUF_SIZE;i ++) { door[i] = 0; }

  if (argc < 2)
  { printf("paramenter 1: the door data\n"); return 0; }

  fp = fopen(argv[1], "rb");
  count = fread(door, 22, 256, fp);

  signed_count = (int)count;
  printf("count = %d\n", signed_count);

  for (i = 0;i < signed_count;i ++)
  {
   if (i*22 >= BUF_SIZE)
   { printf("Error: buffer overflow: BS: %d i: %d\n", BUF_SIZE, i); }
   else
   {
     /*printf("Loc[%d]: Door Name: %s\n", i, door+i*22);*/
    printf("INSERT INTO door VALUES ('%d', '%s', '');\n", i, door+i*22);
   }
  }

  fclose(fp);
  return 0;
}


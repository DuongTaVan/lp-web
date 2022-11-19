<template>
  <div class="w-100 teacher-header">
    <div class="d-flex justify-content-between w-100 header-body">
      <div class="d-flex flex-row user-info">
        <img height="60px" class="user-avatar" width="60px"
             :src="profileImage ? profileImage : teacherInfo.profile_image" alt="">
        <div class="d-flex flex-column">
          <span class="nickname">{{ teacherInfo.full_name }}</span>
          <div class="card__content__rate__rating d-flex align-items-center ml-0">
            <ul class="card__content__rate__rating__list-rating">
              <template v-for="i in 10">
                <li :key="i" v-if="(i - 1) < ratingProcess * 2 && (i - 1) % 2 !== 0"
                    class="card__content__rate__rating__list-rating__even">
                  <i class="fa fa-star-half  rating-active"></i>
                </li>
                <li :key="i" v-else-if="(i - 1) < ratingProcess * 2">
                  <i class="fa fa-star-half  rating-active"></i>
                </li>
                <li :key="i" v-else-if="(i - 1) % 2 !== 0" class="card__content__rate__rating__list-rating__even">
                  <i class="fa fa-star-half"></i>
                </li>
                <li :key="i" v-else>
                  <i class="fa fa-star-half"></i>
                </li>
              </template>
            </ul>
            <span class="rating-avg">{{ Math.floor(Number(ratingProcess) * 10) / 10 }}</span>
            <span class="rating-total">(レビュー{{ rating.sum_rating ? rating.sum_rating : 0 }} 件)</span>
          </div>
        </div>
      </div>
      <div class="d-flex flex-column align-items-end item-container">
        <span class="login-info">最終ログイン：{{ teacherInfo.last_login | lastLoginFilter }}</span>
        <div class="d-flex flex-row header-item-detail">
          <span class="item"><span class="label">開催実績:</span> {{ teacherInfo.countCourseScheduleHeld }}</span>
          <span class="item"><span class="label">利用者数:</span> {{ teacherInfo.countHoldingResult }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    teacherInfo: Object,
    rating: Object,
    profileImage: String
  },
  computed: {
    ratingProcess() {
      return this.rating.avg_rating ? this.rating.avg_rating : 0;
    }
  },
  filters: {
    lastLoginFilter(val) {
      if (!val) return '24時間以内';
      let date1 = new Date(val);
      let now = new Date();
      const diffTime = Math.abs(now - date1);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60));
      if (diffDays < 24) return '24時間以内';
      return Math.ceil(diffDays / 24) + '数日以内';
    }
  }
}
</script>

<style scoped lang="scss">
.teacher-header {
  .header-body {
    border-bottom: 1px solid rgba(78, 87, 104, 0.2);
    padding: 15px 0px;
  }

  .card__content__rate {
    &__rating {
      width: auto;
    }
  }
}

.user-info {
  .user-avatar {
    border-radius: 50%;
    border: 1.9309px solid #46CB90;
    margin-right: 25px;
    object-fit: cover;
  }

  .nickname {
    font-size: 16px;
    font-weight: 600;
    line-height: 24px;
    color: #2A3242;
  }

  .rating-avg {
    font-size: 14px;
    font-weight: 700;
    color: #2A3242;
  }

  .rating-total {
    padding-left: 3px;
    font-size: 12px;
    color: #2A3242;
    font-weight: 300;
  }

  .card__content__rate__rating__list-rating {
    color: #CCC;

    &.rating-active {
      color: #ffd545;
    }
  }
}

.item-container {
  justify-content: space-around;

  .login-info {
    color: #4E5768;
    font-size: 12px;
  }

  .item {
    width: 117px;
    height: 31px;
    background: #FFFFFF;
    border-radius: 5px;
    margin-left: 8px;
    font-size: 14px;
    line-height: 31px;
    color: #2A3242;
    text-align: center;
    font-weight: 700;

    .label {
      font-weight: 400;
    }
  }
}
@media screen and (max-width: 635px) {
  .header-body {
    flex-direction: column;
  }
}
</style>
<style>
.title-wrapper {
  background-color: #F1F4F6 !important;
}
</style>